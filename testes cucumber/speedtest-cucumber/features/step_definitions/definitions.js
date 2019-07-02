const { Given, When, Then } = require('cucumber');
const assert = require('assert');
const { driver } = require('../support/web_driver');
const webdriverjs = require('webdriverio');

Given(/^Browse to web site "([^"]*)"$/, async function(url) {
    console.log("This step opens localhost/speedtest_admin/index.php in the browser")
    await driver.get(url);
});

Then(/^click save_button button$/, async function () {
    console.log("This step clicks the save_btn button in the index.php");
    return driver.findElement({ id: 'save_btn' }).click();
});

When(/^input servidorEspecifico  receives <value>$/, async function () {
    console.log("This step writes(sendKeys) a value to servidorEspecifico input in the index.php");
    return driver.findElement({ id: 'servidorEspecifico' }).sendKeys("http://www.speedtest.net/speedtest-servers-static.php");
});

When(/^input maxServer receives <value>$/, async function () {
    console.log("This step writes(sendKeys) a value to maxServer input in the index.php");
    return driver.findElement({ id: 'maxServer' }).sendKeys("10");
});

When(/^input intervaloTempo receives <value>$/, async function () {
    console.log("This step writes(sendKeys) a value to intervaloTempo input in the index.php");
    return driver.findElement({ id: 'intervaloTempo' }).sendKeys("60000");
});

Then(/^update config must be successful$/, async function () {
    console.log("This step checks if update config of save_btn button was successful");
    var notification = driver.findElement({ className: "bootoast-container" }).isDisplayed().then(result => {
        if (result){
            assert.ok("Successful notification was displayed");
        } else {
            assert.fail("Successful notification was NOT displayed");
        }
    });
    
});

Then(/^index\.php should be oppened$/, async function () {
    console.log("This step checks if current url is equal to desired url  [openConfig in index.php opens index.php]");
    var url = driver.getCurrentUrl().then(result => {
        return assert.equal(result, "http://localhost/speedtest_admin/index.php");
    });
});

When(/^click openConnections button in left navbar$/, async function () {
    console.log("This step clicks the openConnections button in vertical left navbar in the index.php");
    return driver.findElement({ id: 'openConnections' }).click();
});

When(/^click openConfig button in left navbar$/, async function () {
    console.log("This step clicks the openConfig button in vertical left navbar in the index.php");
    return driver.findElement({ id: 'openConfig' }).click();
});

Then(/^conexoes\.php should be oppened$/, async function () {
    console.log("This step checks if current url is equal to desired url  [openConfig in index.php opens conexoes.php]");
    var url = driver.getCurrentUrl().then(result => {
        return assert.equal(result, "http://localhost/speedtest_admin/conexoes.php");
    });
});

When(/^click openCharts button in left navbar$/, async function () {
    console.log("This step clicks the openCharts button in vertical left navbar in the index.php");
    return driver.findElement({ id: 'openCharts' }).click();
});

Then(/^chats\.php should be oppened$/, async function () {
    console.log("This step checks if current url is equal to desired url  [openConfig in index.php opens charts.php]");
    var url = driver.getCurrentUrl().then(result => {
        return assert.equal(result, "http://localhost/speedtest_admin/charts.php");
    });
});

Then(/^current_intervalo_table should not be null$/, async function () {
    console.log("This step checks if current_intervalo_table in index.php is not null");
    driver.findElement({id : 'current_intervalo_table'}).getText().then(result => {
        if (result != "null") {
            assert.ok("Successful current_maxserver_table  was displayed");
        } else {
            assert.fail("Successful current_maxserver_table was NOT displayed");
        }
    });
});

Then(/^current_maxserver_table should not be null$/, async function () {
    console.log("This step checks if current_maxserver_table  in index.php is not null");
    driver.findElement({ id: 'current_maxserver_table' }).getText().then(result => {
        if (result != "null") {
            assert.ok("Successful current_maxserver_table  was displayed");
        } else {
            assert.fail("Successful current_maxserver_table was NOT displayed");
        }
    });
});

Then(/^current_url_table should not be null$/, async function () {
    console.log("This step checks if current_url_table   in index.php is not null");
    driver.findElement({ id: 'current_url_table' }).getText().then(result => {
  
        if (result != "null") {
            assert.ok("Successful current_url_table   was displayed");
        } else {
            assert.fail("Successful current_url_table  was NOT displayed");
        }
    });
});

When(/^click in btn edit$/, async function () {

});

Then(/^table item from "([^"]*)" <id,isp,ip,nome da conexão, pacote> data goes to "([^"]*)" <id_connection,isp_connection, ip_connection, name_connection, pacote_connection>$/, async function (arg1, arg2) {
    
});




