import { $effect, $state, F } from "@effectualjs/core";

import { AddConversation } from "./AddConversation.js";
import { Chat } from "./Chat.js";
import { Config } from "./Config.js";
import { $localStorage, $provideMessageLog, ModelConfig } from "./hooks.js";
import { Icon } from "./Icon.js";
import { Modal } from "./Modal.js";
import { Poster } from "./Poster.js";

import "./Main.css";

export const Main = () => {
    const { activeConversation, conversations, setIndex, addConversation } = $provideMessageLog();
    const configOpen = $state(false);
    const addConversationOpen = $state(false);

    const [config, setConfig] = $localStorage<Partial<ModelConfig>>("model-config", {});

    const closeConfig = () => {
        configOpen.setValue(false);
    };

    const closeConversation = () => {
        addConversationOpen.setValue(false);
    };

    // TODO(zwade): Delay effects to post-render so that we don't need the timeout
    $effect(() => {
        if (!config.userName) {
            setTimeout(() => configOpen.setValue(true), 1);
        }
    });

    return (
        <div class="main">
            <Poster $slot:title={`Wanted: ${conversations[activeConversation].name}`}>
                <div class="main-content">
                    <div class="sidebar">
                        <div class="conversation-list">
                            {conversations.map((conversation, i) => (
                                <div
                                    key={conversation.name}
                                    class="conversation-list-item"
                                    $on:click={() => setIndex(i)}
                                >
                                    {conversation.name}
                                </div>
                            ))}

                            <div
                                key={"add-new"}
                                class="conversation-list-item add-conversation"
                                $on:click={() => addConversationOpen.setValue(true)}
                            >
                                + Add
                            </div>
                        </div>
                    </div>

                    <div class="chat-box">
                        <Chat config={config} />
                    </div>

                    <div class="settings">
                        <Icon name="settings" $on:click={() => configOpen.setValue(true)} size={2.5} />
                    </div>
                </div>
            </Poster>

            <Modal open={configOpen.value} $on:close={closeConfig} $slot:title={<div>Settings</div>}>
                <Config config={config} $on:close={closeConfig} $on:configChange={setConfig} />
            </Modal>

            <Modal
                open={addConversationOpen.value}
                $on:close={() => addConversationOpen.setValue(false)}
                $slot:title={<div>Gab Wit' Someuhn</div>}
            >
                <AddConversation $on:close={closeConversation} $on:create={addConversation} />
            </Modal>
        </div>
    );
};
