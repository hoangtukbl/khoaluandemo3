import { F } from "@effectualjs/core";
import { $state } from "@effectualjs/reconciler";

export const ReactivePortalTest = () => {
    const store = $state(0);
    console.log(store.value);

    return (
        <div>
            <div>Value: {store.value}</div>
            <button $on:click={() => store.set((val) => val + 1)}>Increment</button>
        </div>
    );
};
