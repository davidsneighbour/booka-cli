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
 * @category   Modules|Api|Core
 * @package    Users
 * @author     Patrick Kollitsch <patrick@davids-neighbour.com>
 * @copyright  2007-2020 - David's Neighbour Part., Ltd.
 * @license    https://inkohsamui.com/license.txt proprietary
 * @version    11.9.92
 * @link       https://inkohsamui.com/
 * @since      11.9.92
 * @filesource
 */

var generalCommands = {
  submit: function() {
    this.api.pause(1000);
    return this.waitForElementVisible('@submitButton', 1000)
      .click('@submitButton')
      .waitForElementNotPresent('@submitButton');
  }
};

module.exports = {
  commands: [generalCommands],
};

