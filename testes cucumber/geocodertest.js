const notifier = require('node-notifier');
var opn = require('opn');

          notifier.notify(
            {
              title: "SPEEDTEST",
              subtitle: "Novo IP detectado",
              message: "Para inserir nome ao IP clique aqui",
              sound: true, // Case Sensitive string for location of sound file, or use one of macOS' native sounds (see below)
              icon: 'Terminal Icon', // Absolute Path to Triggering Icon
              contentImage: void 0, // Absolute Path to Attached Image (Content Image)
              open: void 0, // URL to open on Click
              wait: true, // Wait for User Action against Notification or times out. Same as timeout = 5 seconds

              // New in latest version. See `example/macInput.js` for usage
              timeout: 5, // Takes precedence over wait if both are defined.
              closeLabel: void 0, // String. Label for cancel button
              actions: void 0, // String | Array<String>. Action label or list of labels in case of dropdown
              dropdownLabel: void 0, // String. Label to be used if multiple actions
              reply: false // Boolean. If notification should take input. Value passed as third argument in callback and event emitter.
            },
            function(error, response, metadata) {
              console.log(response, metadata);
              console.log("uie");
              opn('http://localhost/startbootstrap-sb-admin-gh-pages/relatorios.html');

            }
          );
