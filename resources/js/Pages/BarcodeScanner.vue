<script>

import {Html5QrcodeScanner} from "html5-qrcode";
export default {
    data() {
        return {
            html5QrcodeScanner: null
        };
    },
    computed: {
    },
    props: {
    },
    mounted() {
        this.initScanner()
    },
    beforeDestroy() {
        // Remove the scroll event listener when the component is dest
    },
    methods: {
        initScanner() {
            function onScanSuccess(decodedText, decodedResult) {
                // handle the scanned code as you like, for example:
                console.log(`Code matched = ${decodedText}`, decodedResult);
            }

            function onScanFailure(error) {
                // handle scan failure, usually better to ignore and keep scanning.
                // for example:
                console.warn(`Code scan error = ${error}`);
            }

            let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: {width: 250, height: 250} },
            false);

            html5QrcodeScanner.render(this.onScanSuccess, this.onScanFailure)
        }
    }
}
</script>


<template>
    <div id="reader" width="600px">
    </div>
</template>
