import express from "express";
import { body, validationResult } from "express-validator";
import { db } from "../server.js";

const router = express.Router();

router.post("/register", [
  body("name").trim().isLength({ min: 3 }).withMessage("Name too short"),
  body("email").isEmail().withMessage("Invalid email")
], async (req, res) => {
  const errors = validationResult(req);
  if (!errors.isEmpty()) {
    return res.status(400).json({ success: false, message: errors.array()[0].msg });
  }

  const { name, email } = req.body;

  try {
    await db.collection("registrations").insertOne({ name, email, status: "confirmed" });
    res.json({ success: true, message: "Registration successful!" });
  } catch (err) {
    res.status(500).json({ success: false, message: "Server error" });
  }
});

export default router;
