import bodyParser from "body-parser";
import express from "express";

import { ApiRouter } from "./api.js";

const app = express();

app.use(bodyParser.json());
app.use("/api", ApiRouter);
app.use("/dist", express.static(new URL("../../client/dist", import.meta.url).pathname));
app.use("/", (req, res) => {
    res.sendFile(new URL("../../client/index.html", import.meta.url).pathname);
});

app.listen("3030", () => {
    console.log("Server listening on port 3030");
});
