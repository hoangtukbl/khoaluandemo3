import { randomBytes } from "node:crypto";
import sq3 from "sqlite3";

import { Conversation } from "./chat.js";

const db = new sq3.Database("./db.sqlite3");
db.exec(`
    CREATE TABLE IF NOT EXISTS saved_conversation (
        uid TEXT PRIMARY KEY,
        conversation TEXT
    );
`);

export const saveConversation = (conversation: any) => {
    const uid = randomBytes(16).toString("hex");
    const stmt = db
        .prepare("INSERT INTO saved_conversation (uid, conversation) VALUES (?, ?)")
        .run([uid, JSON.stringify(conversation)], () => stmt.finalize());

    return uid;
};

export const retrieveConversation = (uid: string) => {
    return new Promise<Conversation | null>((resolve, reject) => {
        const stmt = db.prepare("SELECT conversation FROM saved_conversation WHERE uid = ?").get(uid, (err, row) => {
            stmt.finalize();
            if (err) {
                reject(err);
            }

            if (row) {
                resolve(JSON.parse((row as any).conversation));
            } else {
                resolve(null);
            }
        });
    });
};
