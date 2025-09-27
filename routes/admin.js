import express from "express";
import { Parser } from "json2csv";
import { db } from "../server.js";

const router = express.Router();

// Search + pagination
router.get("/registrations", async (req, res) => {
  const { page = 1, limit = 10, search = "" } = req.query;
  const query = search ? { name: { $regex: search, $options: "i" } } : {};

  const regs = await db.collection("registrations")
    .find(query)
    .skip((page - 1) * limit)
    .limit(parseInt(limit))
    .toArray();

  const total = await db.collection("registrations").countDocuments(query);
  res.json({ regs, total, page: parseInt(page), pages: Math.ceil(total / limit) });
});

// CSV Export
router.get("/export", async (req, res) => {
  const participants = await db.collection("registrations").find({}).toArray();
  const fields = ["name", "email", "status"];
  const parser = new Parser({ fields });
  const csv = parser.parse(participants);

  res.header("Content-Type", "text/csv");
  res.attachment("participants.csv");
  res.send(csv);
});

export default router;
