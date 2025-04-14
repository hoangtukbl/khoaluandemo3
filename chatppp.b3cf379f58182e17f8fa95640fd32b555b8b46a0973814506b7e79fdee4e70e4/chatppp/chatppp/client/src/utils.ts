export const cls = (...args: (string | undefined | null | false)[]): string => {
    return args.filter((arg) => !!arg).join(" ");
};
