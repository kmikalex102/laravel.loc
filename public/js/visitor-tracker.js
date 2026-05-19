(function () {
    const API_URL = "https://laravel.loc/api/track";

    async function getIpInfo() {
        const res = await fetch("https://ipapi.co/json/");
        return await res.json();
    }

    function getDevice() {
        return navigator.userAgent;
    }

    async function sendData() {
        try {
            const ipData = await getIpInfo();

            const payload = {
                ip: ipData.ip,
                domain: window.location.hostname,
                url: window.location.href,
                api_key: 'your_api_key_here',
                city: ipData.city,
                country: ipData.country_name,
                device: getDevice(),
                time: new Date().toISOString()
            };

            await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });

        } catch (e) {
            console.error('Tracking error:', e);
        }
    }

    sendData();
})();
