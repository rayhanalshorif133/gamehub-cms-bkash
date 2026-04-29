// Encryption key (must match the server-side)
/*const encryptionKey = runtime.globalVars.mosfet.toString();

// Get score from Construct 3's global variable
function getScore() {
    const SCORE = runtime.globalVars.appleCount.toString();
    return SCORE; // Assuming appleCount holds the score
}

// Helper function: Encrypt using AES-128-CBC
async function encrypt(text) {
    const key = new TextEncoder().encode(encryptionKey);
    const iv = crypto.getRandomValues(new Uint8Array(16)); // Generate random IV

    const algorithm = { name: "AES-CBC", iv: iv };
    const cryptoKey = await crypto.subtle.importKey("raw", key, algorithm, false, ["encrypt"]);

    const encrypted = await crypto.subtle.encrypt(algorithm, cryptoKey, new TextEncoder().encode(text));

    // Combine IV and encrypted data into a single Uint8Array
    const combined = new Uint8Array(iv.length + encrypted.byteLength);
    combined.set(iv);
    combined.set(new Uint8Array(encrypted), iv.length);

    // Convert to Base64 string
    return btoa(String.fromCharCode(...combined));
}

// Helper function: Grab URL parameters
function getUrlParams() {
    const params = {};
    const queryString = window.location.search.substring(1);
    const pairs = queryString.split("&");
    pairs.forEach((pair) => {
        const [key, value] = pair.split("=");
        params[decodeURIComponent(key)] = decodeURIComponent(value || "");
    });
    return params;
}

// Main function: Encrypt and send data
window.onGameOver = async function () {
    const params = getUrlParams();
    const token = params["token"];
    const keyword = params["keyword"];

    if (!token || !keyword) {
        window.location.href = `https://gp.bdgamers.club/home`;
        return;
    }

    const score = getScore() ? getScore() : 0; // Retrieve score
    const tokenKeyword = `${token}_${keyword}`; // Combine token and keyword

    try {
        const encryptedTokenKeyword = await encrypt(tokenKeyword); // Encrypt token_keyword
        const encryptedScore = await encrypt(score); // Encrypt score

        const url = `https://gp.bdgamers.club/api/score/?pengenal=${encryptedTokenKeyword}&puntaje=${encryptedScore}`;
		fetch(url)
                    .then((res) => {
                        if (!res.ok) {
                            throw new Error(`HTTP error! Status: ${res.status}`);
                        }
                        return res.json(); // Parse the JSON data
                    })
                    .then((data) => {
                        sessionStorage.setItem('mac', data.mac);
                    })

    } catch (error) {
        console.error("Error sending data:", error);
    }
};
*/