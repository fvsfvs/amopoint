(async () => {
    const counterUrl = 'http://r90372q4.beget.tech/visitcounter/counter.php';
    const cityRequestUrl = "http://ipwho.is/";
    const ipRequestUrl = "https://checkip.amazonaws.com/";

    const site = window.location.host;
    let response = await fetch(ipRequestUrl);
    const ip = await response.text();

    response = await fetch(cityRequestUrl + ip);
    let data = await response.json();

    let formData = new FormData();
    formData.append('city', data.city);
    formData.append('site', site);
    formData.append('ip', ip);
    formData.append('agent', navigator.userAgent);

    fetch(counterUrl, {
        method: 'post',
        body: formData,
    });
})()

  
  
