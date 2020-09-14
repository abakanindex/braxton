var page = require('webpage').create(),
  system = require('system'),
  address, output, size;

address = system.args[1];
output = system.args[2];
page.viewportSize = { width: 2000 height: 600 };
if (system.args.length === 3 && system.args[1].substr(-4) === ".pdf") {
  size = system.args[2].split('*');

  page.paperSize = size.length === 2 ?
    { width: size[0], height: size[1], margin: '0px' } :
    { format: system.args[2], orientation: 'portrait', margin: '1cm' };
}
page.open(address, function (status) {
  if (status !== 'success') {
    console.log('Unable to load the address!');
  } else {
    window.setTimeout(function () {
      page.render(output);
      phantom.exit();
    }, 200);
  }
});