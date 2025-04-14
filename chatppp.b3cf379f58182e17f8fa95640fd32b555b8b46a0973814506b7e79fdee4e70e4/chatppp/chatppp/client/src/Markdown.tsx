import { $effect, F } from "@effectualjs/core";

import "./Markdown.css";

export type MarkdownNodeType = "bold" | "italic" | "code" | "paragraph";

export type MarkdownResult = string | { type: MarkdownNodeType; children: MarkdownResult[] };

interface ParseStack {
    type: MarkdownNodeType | "root";
    startIndex: number;
    lastStart: number;
    children: MarkdownResult[];
}

const parseMarkdown = (body: string): MarkdownResult => {
    const parseStack: ParseStack[] = [{ type: "root", startIndex: 0, lastStart: 0, children: [] }];

    const markdownMap: Record<string, MarkdownNodeType | undefined> = {
        "*": "bold",
        _: "italic",
        "`": "code",
    };

    for (let end = 0; end < body.length; end++) {
        const char = body[end];
        const markdownType = markdownMap[char];
        if (markdownType === undefined) {
            continue;
        }

        const currentStackEl = parseStack[parseStack.length - 1];
        if (parseStack.length === 0 || currentStackEl.type !== markdownType) {
            parseStack.push({ type: markdownType, startIndex: end, lastStart: end + 1, children: [] });
            continue;
        }

        const parentEl = parseStack[parseStack.length - 2];
        const textBeforeOurStart = body.slice(parentEl.lastStart, currentStackEl.startIndex);
        if (textBeforeOurStart) {
            parentEl.children.push(textBeforeOurStart);
            parentEl.lastStart = end + 1;
        }

        const textAtOurEnd = body.slice(currentStackEl.lastStart, end);
        if (textAtOurEnd) {
            currentStackEl.children.push(textAtOurEnd);
            currentStackEl.lastStart = end + 1;
        }

        parentEl.children.push({
            type: currentStackEl.type,
            children: currentStackEl.children,
        });

        parseStack.pop();
    }

    if (parseStack.length > 1) {
        return "Invalid markdown";
    }

    const finalText = body.slice(parseStack[0].lastStart);
    if (finalText) {
        parseStack[0].children.push(finalText);
    }

    return { type: "paragraph", children: parseStack[0].children };
};

export interface RawMarkdownProps {
    el: MarkdownResult;
}

export const RawMarkdown = (props: RawMarkdownProps) => {
    if (typeof props.el === "string") {
        return props.el;
    }

    return (
        <div class={`md-${props.el.type}`}>
            {props.el.children.map((child, i) => (
                <RawMarkdown el={child} key={i} />
            ))}
        </div>
    );
};

export interface MarkdownProps {
    body: string;
}

export const Markdown = (props: MarkdownProps) => {
    const parsed = $effect(
        (body) => {
            return parseMarkdown(body);
        },
        [props.body],
    );

    return (
        <div class="markdown-res">
            <RawMarkdown el={parsed} />
        </div>
    );
};
