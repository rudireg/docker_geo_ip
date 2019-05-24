/**
 * Проверка IP адреса
 */
var GeoIp = {
    response: null,
    btn: null,
    http: null,
    ip: null,
    init: function() {
        this.response = document.getElementById('response');
        this.btn = document.getElementById('check-ip-button');
        this.ip = document.getElementById('ip');
        this.btn.addEventListener('click', () => {
            this.setResponseMsg('Wait ...');
            this.http = new XMLHttpRequest();
            this.http.onreadystatechange = this.state;
            this.http.onerror = this.error;
            this.http.open('GET', '/api/check/'+this.ip.value, true);
            this.http.send();
      });
    },
    state: function() { // XMLHttpRequest context
        try {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                GeoIp.setResponseMsg(this.responseText);
            }
        } catch (e) {
            GeoIp.setResponseMsg(`Error ${e.name} ${e.message} ${e.stack}`)
        }
    },
    error: function(e) {
        GeoIp.setResponseMsg('Error ' + e.target.status + ' occurred while checking the IP');
    },
    setResponseMsg: function(msg) {
        this.response.classList.remove('hide');
        try {
            let result = JSON.parse(msg);
            let data = '<div>';
            for (let item in result) {
                data += `<span>${item}</span>:<span>${result[item]}</span><br/>`;
            }
            data += '</div>';
            this.response.innerHTML = data;
        } catch (e) {
            this.response.innerHTML = msg;
        }
    }
};

window.onload = function () {
    GeoIp.init();
};