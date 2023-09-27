--Insert the following new client to the clients table--
INSERT INTO clients (clientFirstname, clientLastname, clientEmail, clientPassword, comment)
VALUES ('Tony', 'Stark', 'tony@starkent.com', 'Iam1ronM@n', 'I am the real Ironman');

-- Modify the Tony Stark record to change the clientLevel to 3--
UPDATE `clients` SET `clientLevel` = 3 WHERE `clientFirstname` = 'Tony' AND `clientLastname` = 'Stark';

--Modify the "GM Hummer" record to read "spacious interior" rather than "small interior"--
UPDATE inventory SET invDescription = REPLACE(invDescription, 'small interior', 'spacious interior') WHERE invMake = 'GM' AND invModel = 'Hummer';

--Inner join to select fields from inventory and carclassification:--
SELECT inventory.invModel, carclassification.classificationName FROM inventory INNER JOIN carclassification ON inventory.classificationId = carclassification.classificationId WHERE carclassification.classificationName = 'SUV';

--Delete the Jeep Wrangler:--
DELETE FROM inventory WHERE invMake = 'Jeep' AND invModel = 'Wrangler';

--Update file paths in Inventory table:--
UPDATE inventory SET invImage = CONCAT('/phpmotors', invImage), invThumbnail = CONCAT('/phpmotors', invThumbnail); 