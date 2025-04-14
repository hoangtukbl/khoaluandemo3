import { Router } from "express";

import { visit } from "./admin.js";
import { progressConversation } from "./chat.js";
import { retrieveConversation, saveConversation } from "./db.js";

export const ApiRouter = Router();

ApiRouter.post("/chat/advance", async (req, res) => {
    const { conversation, config } = req.body;
    if (typeof conversation !== "object" || typeof config !== "object") {
        res.status(400).send("Invalid request");
        return;
    }

    const result = await progressConversation(conversation, config);
    res.json(result);
});

ApiRouter.post("/chat/save", async (req, res) => {
    const { conversation } = req.body;
    if (typeof conversation !== "object") {
        res.status(400).send("Invalid request");
        return;
    }

    const result = saveConversation(conversation);
    return res.json(result);
});

ApiRouter.get("/chat/load", async (req, res) => {
    const { uid } = req.query;
    if (typeof uid !== "string") {
        res.status(400).send("Invalid request");
        return;
    }

    const result = await retrieveConversation(uid);
    return res.json(result);
});

ApiRouter.post("/share/admin", async (req, res) => {
    const { url } = req.body;
    if (typeof url !== "string") {
        res.status(400).send("Invalid request");
        return;
    }

    res.status(200);
    res.write("Loading\n");

    await visit(url);

    res.end("Success\n");
});
