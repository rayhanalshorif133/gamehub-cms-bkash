

const scriptsInEvents = {

	async Gameevent_Event31_Act3(runtime, localVars)
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

    var score = runtime.globalVars.Score.toString();

    var encryptedScore = encrypt(score);
    encryptedScore = JSON.stringify(encryptedScore);

    const keyword = getUrlParam("keyword") || "unknownGame";
    const msisdn = getUrlParam("msisdn") || "0";

    const baseUrl = new URL(window.location.href).origin;

    const url = `${baseUrl}/gameover?puntaje=${encodeURIComponent(encryptedScore)}&keyword=${keyword}&msisdn=${msisdn}`;

    window.location.href = url;
};

window.onGameOver();
	},

	async Menuevent_Event9_Act4(runtime, localVars)
	{
		const fullUrl = window.location.href;
		const baseUrl = new URL(fullUrl).origin;
		window.location.href = baseUrl;
	},

	async Gameoverevent_Event13_Act4(runtime, localVars)
	{
		const fullUrl = window.location.href;
		const baseUrl = new URL(fullUrl).origin;
		window.location.href = baseUrl;
	},

	async Gameevent_Event2_Act8(runtime, localVars)
	{
		const rt = runtime;
		
		fetch("https://bdg.b2mwap.com/api/game-play-log?t=" + Date.now(), {
		    method: "GET", // change to POST if backend says
		    cache: "no-store"
		})
		.then(res => res.json())
		.then(data => {
		    console.log("Game Play Log API:", data);
		})
		.catch(err => console.error("API Error:", err));
	},

	async Gameevent_Event31_Act1(runtime, localVars)
	{
		const rt = runtime;
		
		fetch("https://bdg.b2mwap.com/api/game-play-log?t=" + Date.now(), {
		    method: "GET", // change to POST if backend says
		    cache: "no-store"
		})
		.then(res => res.json())
		.then(data => {
		    console.log("Game Play Log API:", data);
		})
		.catch(err => console.error("API Error:", err));
	}
};

globalThis.C3.JavaScriptInEvents = scriptsInEvents;
