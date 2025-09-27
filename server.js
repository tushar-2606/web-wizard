import express from "express";
import session from "express-session";
import MongoStore from "connect-mongo";
import path from "path";
import { fileURLToPath } from "url";
import mongoose from "mongoose";
import bcrypt from "bcrypt";
import dotenv from "dotenv";

import registerRouter from "./routes/register.js";
import adminRouter from "./routes/admin.js";
import User from "./models/User.js";

dotenv.config();

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const app = express();
const PORT = process.env.PORT || 3000;

// MongoDB connection
mongoose.connect(process.env.MONGO_URI, {
  useNewUrlParser: true,
  useUnifiedTopology: true
}).then(() => console.log("MongoDB connected"))
  .catch(err => console.error(err));

const db = mongoose.connection;

// Make db accessible in routes
app.use((req, res, next) => {
  req.db = db;
  next();
});

// Middleware
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, "public")));

// Session
app.use(session({
  secret: process.env.SESSION_SECRET || "secret_dev",
  resave: false,
  saveUninitialized: false,
  store: MongoStore.create({ mongoUrl: process.env.MONGO_URI }),
  cookie: { maxAge: 1000 * 60 * 60 * 4 } // 4 hours
}));

// Admin login page
app.get("/admin/login", (req, res) => {
  res.sendFile(path.join(__dirname, "public/admin-login.html"));
});

// Handle login
app.post("/admin/login", async (req, res) => {
  const { username, password } = req.body;
  const user = await User.findOne({ username });

  if (user && await bcrypt.compare(password, user.passwordHash)) {
    req.session.admin = true;
    res.redirect("/admin/dashboard");
  } else {
    res.send("Invalid username or password");
  }
});

// Middleware to protect admin routes
function requireAdmin(req, res, next) {
  if (req.session && req.session.admin) {
    next();
  } else {
    res.redirect("/admin/login");
  }
}

// Admin dashboard
app.get("/admin/dashboard", requireAdmin, (req, res) => {
  res.sendFile(path.join(__dirname, "public/admin.html"));
});

// Logout
app.get("/admin/logout", (req, res) => {
  req.session.destroy();
  res.redirect("/admin/login");
});

// Routes
app.use("/", registerRouter); // registration route
app.use("/admin", requireAdmin, adminRouter); // admin routes protected

app.listen(PORT, () => {
  console.log(`Server running on http://localhost:${PORT}`);
});

export { db };
