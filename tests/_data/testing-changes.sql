-- contains test date for local testing
-- DO NOT ADD THIS TO A LIVE DATABASE
-- @see https://codeception.com/docs/modules/Db

-- add default cashbook for users
# INSERT INTO `booka_users_settings` (`userid`, `setting`, `value`)
# VALUES
# ((SELECT userid FROM booka_users WHERE name LIKE 'testowner'), 'default_cashbook', '1043'),
# ((SELECT userid FROM booka_users WHERE name LIKE 'testmanager'), 'default_cashbook', '1043'),
# ((SELECT userid FROM booka_users WHERE name LIKE 'testbooker'), 'default_cashbook', '1043');

-- functions to get the current dates (to insert test bookings/trips aso later)
-- SELECT @currentdate := CURRENT_DATE();
-- SELECT @currenttime := CURRENT_TIME();
-- SELECT @currenttimestamp := CURRENT_TIMESTAMP();

-- update omise keys to testing environment
UPDATE settings SET value = 'pkey_test_5d598co9rvou8ykx7yc' WHERE setting='omise_public_key';
UPDATE settings SET value = 'skey_test_5d598coa1bfet372z8i' WHERE setting='omise_private_key';

-- update notification channel to internal testing channel
UPDATE settings
SET value = 'https://hooks.slack.com/services/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'
WHERE setting='slack_notifications_channelhook';
UPDATE settings SET value = 'GBQHY8UKW' WHERE setting='slack_notifications_channel';
