<template>
    <div ref="tradingviewWidgetContainer" style="width: 100%; height: 300px;"></div>
</template>
  
<script>
  export default {
    props: {
      symbol: {
        type: String,
        required: true,
      },
    },
  
    mounted() {
      this.loadTradingViewScript().then(() => {
        this.initTradingViewChart();
      });
    },
  
    data() {
        return {
          tvWidget: null,
        };
    },
    methods: {
      loadTradingViewScript() {
        return new Promise((resolve) => {
          if (window.TradingView) {
            resolve();
            return;
          }

          const script = document.createElement("script");
          script.src = "https://s3.tradingview.com/tv.js";
          script.async = true;
          script.onload = () => {
            resolve();
          };
          document.body.appendChild(script);
        });
      },
      initTradingViewChart() {
        if (!window.TradingView) {
          console.error("TradingView library not loaded");
          return;
        }

        const container = this.$refs.tradingviewWidgetContainer;
        const containerId = 'tradingview-widget';
        container.id = containerId;
        
        this.tvWidget = new TradingView.widget({
          "autosize": true,
          "symbol": `${this.symbol}USDT`,
          "interval": "1D",
          "timezone": "Etc/UTC",
          "theme": "dark",
          "style": "1",
          "locale": "en",
          "toolbar_bg": "#f1f3f6",
          "enable_publishing": false,
          "withdateranges": true,
          "range": "12m",
          "container_id": containerId
        });
      }
    },
  
    watch: {
      symbol(newValue) {
        // Remove existing widget and create a new one with the updated symbol
        if (this.tvWidget !== null) {
          this.tvWidget.remove();
        }
  
        this.initTradingViewChart();
      },
    },
  };
</script>