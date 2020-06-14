const Services = {};

const loadServices = () => {
  try {
    // eslint-disable-next-line global-require,import/no-extraneous-dependencies
    Services.chromedriver = require('chromedriver');
  } catch (err) {
    // eslint-disable-next-line no-console
    console.log('error initializing chromedriver');
  }

  try {
    // eslint-disable-next-line global-require,import/no-extraneous-dependencies
    Services.geckodriver = require('geckodriver');
  } catch (err) {
    // eslint-disable-next-line no-console
    console.log('error initializing geckodriver');
  }
};

loadServices();

// eslint-disable-next-line no-undef
module.exports = {

  src_folders: [
    'tests/nightwatch',
  ],

  // See https://nightwatchjs.org/guide/working-with-page-objects/
  page_objects_path: 'tests/nightwatch_pageobjects',

  // See https://nightwatchjs.org/guide/extending-nightwatch/#writing-custom-commands
  custom_commands_path: '',

  // See https://nightwatchjs.org/guide/extending-nightwatch/#writing-custom-assertions
  custom_assertions_path: '',

  // See https://nightwatchjs.org/guide/#external-globals
  globals_path: '',

  output_folder: 'tmp/nightwatch_output',

  webdriver: {
    start_process: true,
    log_path: 'tmp/',
  },

  test_settings: {
    default: {

      launch_url: 'https://booka/',

      screenshots: {
        enabled: true,
        path: 'tmp/nightwatch_screens',
        on_failure: true,
        on_error: true,
      },

      desiredCapabilities: {
        browserName: 'chrome',
        chromeOptions: {
          args: [
            '--ignore-certificate-errors',
            '--allow-insecure-localhost',
            // '--headless',
          ],
        },
      },

      webdriver: {
        port: 9515,
        server_path: (Services.chromedriver ? Services.chromedriver.path : ''),
        cli_args: [
          '--verbose',
        ],
      },
    },

    firefox: {
      desiredCapabilities: {
        browserName: 'firefox',
        alwaysMatch: {
          acceptInsecureCerts: true,
          'moz:firefoxOptions': {
            args: [
              // '-headless',
              '-verbose',
            ],
          },
        },
      },

      webdriver: {
        server_path: (Services.geckodriver ? Services.geckodriver.path : ''),
        port: 4444,
        cli_args: [
          '-vv',
        ],
      },
    },

    chrome: {
      // all defined in default
    },
  },

  test_workers: {
    enabled: true,
    workers: 'auto',
  },
};
