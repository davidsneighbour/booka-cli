/*
 * BooKa 13
 *
 * Copyright (c) 2007-2020 - David's Neighbour Part., Ltd.
 * All rights reserved.
 *
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 * Moral rights are preserved. Proprietary and confidential software.
 * Written by Patrick Kollitsch <patrick@davids-neighbour.com>
 *
 * @category   Tests
 * @package    Core
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  2007-2020 - David's Neighbour Part., Ltd.
 * @license    https://inkohsamui.com/license.txt proprietary
 * @version    11.9.86
 * @link       https://inkohsamui.com/
 * @since      11.9.86
 * @filesource
 */

// noinspection JSUnusedGlobalSymbols
module.exports = {

  '@tags': 'general,base',

  //reporter(results) {
    // eslint-disable-next-line no-console
    //console.log('results', results);
  //},

  // eslint-disable-next-line no-unused-vars
  before(browser) {
    // eslint-disable-next-line no-console
    //console.log('Setting up...');
  },

  // eslint-disable-next-line no-unused-vars
  after(browser) {
    // eslint-disable-next-line no-console
    //console.log('Closing down...');
  },

  beforeEach(browser, done) {
    // performing an async operation
    setTimeout(() => {
      // finished async duties
      done();
      // eslint-disable-next-line no-console
      //console.log('start');
    }, 100);
  },

  afterEach(browser, done) {
    // performing an async operation
    setTimeout(() => {
      // finished async duties
      done();
      // eslint-disable-next-line no-console
      //console.log('finish');
    }, 200);
  },

  Booka(browser) {
    const login = browser.page.login();

    login.navigate()
      .waitForElementVisible('body')
      .assert.visible('@submit')
      .setValue('@email', 'testowner@example.com')
      .setValue('@password', 'testowner')
      .click('@submit')
      .waitForElementVisible('body');

    browser.end();
  },
};
