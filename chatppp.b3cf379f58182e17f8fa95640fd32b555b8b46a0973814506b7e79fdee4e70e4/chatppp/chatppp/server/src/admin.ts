import { launch } from "puppeteer";

const BASE_URL = process.env.BASE_URL || "http://localhost:3030";
const FLAG = process.env.FLAG || "flag{testing_flag}";

const sleep = (ms: number) => new Promise((resolve) => setTimeout(resolve, ms));

const newBrowser = async () => {
    const browser = await launch({
        headless: true,
        args: ["--no-sandbox", "--disable-setuid-sandbox", "--js-flags=--noexpose_wasm,--jitless"],
        timeout: 2_000,
    });

    return Object.assign(browser, {
        async [Symbol.asyncDispose]() {
            await browser.close();
        },
    });
};

export const visit = async (url: string) => {
    console.log(`Visiting ${url}`);
    await using browser = await newBrowser();

    const page = await browser.newPage();

    await page.goto(BASE_URL);
    await page.evaluate((flag) => {
        localStorage.setItem("flag", flag);
    }, FLAG);

    await page.close();

    const victimPage = await browser.newPage();
    await victimPage.goto(url, { timeout: 2_000 });
    await victimPage.waitForNetworkIdle({ timeout: 1_000 });

    // The admin is very friendly and will gladly click a button if they see one.
    const button = await victimPage.$("button");
    if (button) {
        button.click();
    }

    await sleep(5_000);

    await victimPage.close();
    console.log(`Completed visit of ${url}`);
};
