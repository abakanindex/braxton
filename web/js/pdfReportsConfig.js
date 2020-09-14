var page = require('webpage').create(),
  system = require('system'),
  address, output, reportName;

address = system.args[1];
output = system.args[2];
reportName = system.args[3];

page.paperSize = {
  format: 'A4',
  orientation: 'portrait',
  margin: {
    top: "1.5cm",
    bottom: "1cm"
  },
  footer: {
    height: "1cm",
    contents: phantom.callback(function (pageNum, numPages) {
      return '' +
        '<div style="margin: 0 1cm 0 1cm; font-size: 0.65em">' +
        '   <div style="color: #888; padding:10px 20px 0 10px; border-top: 1px solid #ccc;">' +
        '       <span>' + reportName+ '</span> ' +
        '       <span style="float:right">' + pageNum + ' / ' + numPages + '</span>' +
        '   </div>' +
        '</div>';
    })
  }
};
page.evaluate(function () {
  var links = document.getElementsByTagName('link');
  for (var i = 0, len = links.length; i < len; ++i) {
    var link = links[i];
    if (link.rel == 'stylesheet') {
      if (link.media == 'screen') { link.media = ''; }
      if (link.media == 'print') { link.media = 'ignore'; }
    }
  }
});
// This will fix some things that I'll talk about in a second
page.settings.dpi = "96";
page.open(address, function (status) {
  if (status !== 'success') {
    console.log('Unable to load the address!');
  } else {
    window.setTimeout(function () {
      page.render(output, {format: 'pdf'});
      phantom.exit();
    }, 2000);
  }
});