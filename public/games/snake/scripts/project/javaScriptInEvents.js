

const scriptsInEvents = {

	async Emainmenu_Event1_Act2(runtime, localVars)
	{

	},

	async Egame_Event33_Act10(runtime, localVars)
	{
		const fullUrl = window.location.href;
		const baseUrl = new URL(fullUrl).origin;
		window.location.href = baseUrl;
	},

	async Egame_Event35_Act15(runtime, localVars)
	{
const encryptionKey = runtime.globalVars.mosfet.toString();

function encrypt(text) {

    const passphrase = encryptionKey;
    const salt = CryptoJS.lib.WordArray.random(128 / 8);

    const keyIv = CryptoJS.PBKDF2(passphrase, salt, {
        keySize: 256 / 32 + 128 / 32,
        iterations: 1000
    });

    const key = CryptoJS.lib.WordArray.create(keyIv.words.slice(0, 8));
    const iv = CryptoJS.lib.WordArray.create(keyIv.words.slice(8, 12));

    const encrypted = CryptoJS.AES.encrypt(text, key, {
        iv: iv,
        padding: CryptoJS.pad.Pkcs7
    });

    return {
        key: key.toString(CryptoJS.enc.Base64),
        salt: salt.toString(CryptoJS.enc.Base64),
        iv: iv.toString(CryptoJS.enc.Base64),
        ciphertext: encrypted.toString()
    };
}

function getUrlParam(name) {
    const params = new URLSearchParams(window.location.search);
    return params.get(name);
}

window.onGameOver = function () {

    var score = runtime.globalVars.appleCount.toString();

    var encryptedScore = encrypt(score);
    encryptedScore = JSON.stringify(encryptedScore);

    const keyword = getUrlParam("keyword") || "unknownGame";
    const msisdn = getUrlParam("msisdn") || "0";

    const baseUrl = new URL(window.location.href).origin;

    const url = `${baseUrl}/gameover?puntaje=${encodeURIComponent(encryptedScore)}`;

    window.location.href = url;
};

window.onGameOver();
	}
};

globalThis.C3.JavaScriptInEvents = scriptsInEvents;
