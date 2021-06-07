/* --- Utils --- */
Minitoring.Utils={
    
    getIpLink: function (IP, service) {
        switch(service){
            case 'abuseipdb':
            case 'abuseipdb.com':
                return '<a href="https://www.abuseipdb.com/check/' + IP + '" target="linkout" class="color-theme">' + IP + '</a>';

            case 'geoip':
            case 'geodatatool':
            case 'geodatatool.com':
                return '<a href="https://www.geodatatool.com/en/?IP=' + IP + '" target="linkout" class="color-theme">' + IP + '</a>';

            default:
                return '<span>' + IP + '</span>';
        }
    }
} 