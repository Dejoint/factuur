var pad = function(tar) {}
var gauge2 = Gauge(
    document.getElementById("gauge2"),
    {
      min: -100,
      max: 100,
      dialStartAngle: 180,
      dialEndAngle: 0,
      value: 60,
      viewBox: "0 0 100 57",
      color: function(value) {
        if(value < 20) {
          return "#5ee432";
        }else if(value < 40) {
          return "#fffa50";
        }else if(value < 60) {
          return "#f7aa38";
        }else {
          return "#ef4655";
        }
      }
    }
);
