// models/User.js
import mongoose from "mongoose";
import bcrypt from "bcrypt";

const userSchema = new mongoose.Schema({
  username: { type: String, required: true, unique: true }, // admin username
  passwordHash: { type: String, required: true },           // hashed password
  name: { type: String, required: true },                  // student name
  email: { type: String, required: true, unique: true },   // student email
  status: { type: String, default: "confirmed" }           // confirmed/waiting
}, { timestamps: true });

// Optional: hash password before saving (for admin only)
userSchema.pre("save", async function(next) {
  if (this.isModified("passwordHash")) {
    const hash = await bcrypt.hash(this.passwordHash, 10);
    this.passwordHash = hash;
  }
  next();
});

const User = mongoose.model("User", userSchema);
export default User;  // ✅ ES Module default export
