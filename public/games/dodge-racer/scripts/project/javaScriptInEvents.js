

const scriptsInEvents = {

	async Game_events_Event1_Act1(runtime, localVars)
	{
		const url = new URL(location.href);
		const mac = url.searchParams.get("mac");
		
		// Get from URL or fallback to session, then finally "unknown"
		const finalMac = mac || sessionStorage.getItem("macAddress") || "unknown";
		    
		runtime.globalVars.macAddress = finalMac;
		sessionStorage.setItem("macAddress", finalMac);
		
		if (mac) {
		    url.searchParams.delete("mac");
		    history.replaceState({}, document.title, url.toString());
		}
	},

	async Game_events_Event1_Act8(runtime, localVars)
	{
		const rts = runtime;
		
		fetch("https://bdg.b2mwap.com/api/game-play-log?t=" + Date.now(), {
		    method: "GET", // change to POST if backend says
		    cache: "no-store"
		})
		.then(res => res.json())
		.then(data => {
		    //console.log("Game Play Log API:", data);
		})
		.catch(err => console.error("API Error:", err));
	},

	async Game_events_Event35_Act6(runtime, localVars)
	{
		const rts = runtime;
		
		fetch("https://bdg.b2mwap.com/api/game-play-log?t=" + Date.now(), {
		    method: "GET", // change to POST if backend says
		    cache: "no-store"
		})
		.then(res => res.json())
		.then(data => {
		    //console.log("Game Play Log API:", data);
		})
		.catch(err => console.error("API Error:", err));
	},

	async Game_events_Event35_Act7(runtime, localVars)
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

    var score = runtime.globalVars.apiScore.toString();
    var get_mac = runtime.globalVars.macAddress.toString();

    var encryptedScore = encrypt(score);
    encryptedScore = JSON.stringify(encryptedScore);

    const keyword = getUrlParam("keyword") || "unknownGame";
    const msisdn = getUrlParam("msisdn") || "0";

    const baseUrl = new URL(window.location.href).origin;

    const url = `${baseUrl}/gameover?mac=${get_mac}&puntaje=${encodeURIComponent(encryptedScore)}`;

    window.location.href = url;
};

window.onGameOver();
	},

	async Game_events_Event46_Act2(runtime, localVars)
	{
		runtime.globalVars.lastSpeed = runtime.globalVars.ScrollSpeed;
	},

	async Main_events_Event4_Act3(runtime, localVars)
	{
		const fullUrl = window.location.href;
		const baseUrl = new URL(fullUrl).origin;
		window.location.href = baseUrl;
	}
};

globalThis.C3.JavaScriptInEvents = scriptsInEvents;
