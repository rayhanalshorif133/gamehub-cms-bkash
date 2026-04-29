

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

	async Game_events_Event1_Act15(runtime, localVars)
	{
		const rt = runtime;
		
		fetch("https://bdg.b2mwap.com/api/check-score")
		.then(res => res.json())
		.then(data => {
		
		    console.log("API:", data);
		
		    // convert safely to boolean
		    const boost = data.boost_active;
		
		    rt.globalVars.boost_active = 
		        boost === true || boost === "true" || boost === 1 || boost === "1";
		
		    console.log("Boost IN Game:", rt.globalVars.boost_active);
		    console.log("Boost IN API:", boost);
		
		})
		.catch(err => console.error("Fetch error:", err));
	},

	async Game_events_Event6_Act1(runtime, localVars)
	{
		const rts = runtime;
		
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

	async Game_events_Event6_Act14(runtime, localVars)
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
    var get_mac =  sessionStorage.getItem("macAddress") || "unknown";

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

	async Game_events_Event6_Act16(runtime, localVars)
	{
		
	},

	async Global_events_Event7_Act1(runtime, localVars)
	{
		const rts = runtime;
		
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

	async Global_events_Event9_Act2(runtime, localVars)
	{
		const fullUrl = window.location.href;
		const baseUrl = new URL(fullUrl).origin;
		window.location.href = baseUrl;
	}
};

globalThis.C3.JavaScriptInEvents = scriptsInEvents;
