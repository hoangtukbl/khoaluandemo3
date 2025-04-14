import { $effect, $state, F } from "@effectualjs/core";

import { loadChat, shareWithAdmin } from "./Api.js";
import { ChatPreview } from "./ChatPreview.js";
import { Conversation } from "./hooks.js";
import { Icon } from "./Icon.js";
import { Poster } from "./Poster.js";

export interface Props {
    matches: Record<string, string | null>;
}

export const Share = (props: Props) => {
    const conversation = $state<Conversation | null>(null);
    const sharing = $state(false);
    const id = props.matches.id as string;

    $effect(
        (id) => {
            loadChat(id).then((chat) => {
                conversation.setValue(chat);
            });
        },
        [id],
    );

    if (!conversation.value) {
        return <Poster $slot:title="">Loading...</Poster>;
    }

    const sendToAdmin = async () => {
        sharing.setValue(true);
        await shareWithAdmin(window.location.href);
        sharing.setValue(false);
    };

    const cta = sharing.value ? (
        <Icon size={3} name={"hourglass_top"} />
    ) : (
        <Icon size={3} name={"present_to_all"} $on:click={sendToAdmin} />
    );
    return (
        <Poster $slot:header-cta={cta} $slot:title={`Wanted: ${conversation.value.name}`}>
            <ChatPreview conversation={conversation.value} />
        </Poster>
    );
};
