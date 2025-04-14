import { $effect, $state, AssignableStore, Store } from "@effectualjs/reconciler";

import { progressChat } from "./Api.js";

export type StateData<T> = [value: T, setValue: (data: T) => void];

export type MessageContent = {
    body: string;
    timestamp: string;
    origin: "user" | "bot";
};

export type Conversation = {
    name: string;
    messages: MessageContent[];
};

export type ModelConfig = {
    userName: string;
    token: string;
};

const Conversations = new AssignableStore<Conversation[]>([
    { name: "Sheriff Fenomena", messages: [] },
    { name: "Big Bad Billy", messages: [] },
    { name: "Doc Slinger", messages: [] },
]);
const ActiveConversation = new Store(0);

export const $provideMessageLog = () => {
    const conversations = Conversations.$provide();
    const activeConversationIdx = ActiveConversation.$provide();

    return {
        conversations: conversations.value,
        activeConversation: activeConversationIdx.value,
        setIndex: (idx: number) => {
            activeConversationIdx.setValue(idx);
        },
        addConversation: (name: string) => {
            conversations.set((c) => [...c, { name, messages: [] }]);
            activeConversationIdx.setValue(conversations.value.length); // It won't propagate immediately
        },
    };
};

export const $useMessageLog = (config: Partial<ModelConfig>) => {
    const [conversations, setConversations] = Conversations.$use();
    const activeConversationIdx = ActiveConversation.$use();

    const conversation = conversations[activeConversationIdx];
    const setConversation = (idx: number, conversation: Conversation) => {
        const updatedConversations = [
            ...conversations.slice(0, activeConversationIdx),
            conversation,
            ...conversations.slice(activeConversationIdx + 1),
        ];

        setConversations(updatedConversations);
    };

    const sendMessage = (message: string) => {
        const updatedConversation: Conversation = {
            name: conversation.name,
            messages: [
                ...conversation.messages,
                {
                    body: message,
                    timestamp: new Date().toISOString(),
                    origin: "user",
                },
            ],
        };

        setConversation(activeConversationIdx, updatedConversation);
        progressChat(updatedConversation, config).then((updatedConversation) => {
            setConversation(activeConversationIdx, updatedConversation);
        });
    };

    return {
        messages: conversations[activeConversationIdx].messages,
        name: conversations[activeConversationIdx].name,
        sendMessage,
    };
};

export function $localStorage<T>(key: string): StateData<T | undefined>;
export function $localStorage<T>(key: string, defaultValue: T): StateData<T>;
export function $localStorage<T>(key: string, defaultValue?: T): StateData<T | undefined> {
    let qualifiedDefault = defaultValue;
    if (localStorage.getItem(key)) {
        qualifiedDefault = JSON.parse(localStorage.getItem(key)!);
    }

    const store = $state<T | undefined>(qualifiedDefault);

    $effect(function* () {
        const callback = (e: StorageEvent) => {
            if (e.key !== key) {
                return;
            }

            const value = localStorage.getItem(key);
            if (value) {
                store.setValue(JSON.parse(value));
            } else {
                store.setValue(defaultValue);
            }
        };

        window.addEventListener("storage", callback);
        yield;

        window.removeEventListener("storage", callback);
    });

    const onChange = (value: T) => {
        localStorage.setItem(key, JSON.stringify(value));
        store.setValue(value);
    };

    return [store.value, onChange] as StateData<T | undefined>;
}

const Hash = Store.create<string>(location.hash.slice(1));
export const $hashState = () => {
    const hash = Hash.$provide();
    $effect(function* () {
        const cb = () => {
            hash.setValue(location.hash.slice(1));
        };

        window.addEventListener("hashchange", cb);
        yield;

        window.removeEventListener("hashchange", cb);
    });

    return hash.value;
};

const RouterStore = new AssignableStore<string>(window.location.pathname);
export const $provideRouter = () => {
    const router = RouterStore.$provide();
    $effect(function* () {
        const callback = () => {
            router.setValue(window.location.pathname);
        };

        window.addEventListener("popstate", callback);
        yield;

        window.removeEventListener("popstate", callback);
    });

    return router.value;
};

export const $useRoute = () => {
    const [route] = RouterStore.$use();

    return route;
};

export const $useRouter = () => {
    const [_route, setRoute] = RouterStore.$use();

    return (route: string) => {
        history.pushState({}, "", route);
        setRoute(route);
    };
};
