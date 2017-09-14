<?php

///////////// MY CRYPTO PORTFOLIO ////////////////////

$myusername = "Unknown Hodler"; // Enter your USERNAME if you wish or else delete/comment out this line.
$mymotto = "HODL the line, profit is always on time (oh oh oh)"; // Enter your MOTTO if you wish or else delete/comment out this line.

$grossinv = 600; // the GROSS amount of the INVESTMENT, including exchange fees. It is whatever you have paid for buying coins minus the mining fees (they have a specific field below). If there are not mining fees then the GROSS INVESTMENT is your TOTAL INVESTMENT. GROSS INVESTMENT = COIN INVESTMENT + EXCHANGE FEES etc.

$doyoumine = "yes"; // Do you mine? Answer with "yes" or "no".
$mininginv = 160; // the MINING INVESTMENT, i.e. your mining expenses, if any. If you don't mine delete/comment out this line or make the value 0.

// Time to register your coins. See the examples below and follow them to register your coins.

$currency = "USD"; // the CURRENCY of your choice. Valid values are: "USD", "CAD", "CNY", "EUR", "GBP", and "BTC". Remember to register your expenses/investments on the same currency.
$coinnr = 7; // The NUMBER of the different kinds of cryptocoins you own, e.g. if you own Bitcoin, Ethereum, and Bitquence this NUMBER will be 3.

// COIN 1
$coin1id = "civic"; //the ID of the coin. the Coin ID of each coin can be found in the CoinMarketCap page of the coin. See here: https://ibb.co/gcG9Wv
$coin1qua = 300; //the QUANTITY of the coin/token.
$coin1inv = 115; // the INVESTMENT you made i.e. how much you paid to buy the coin quantity.
$coin1mined = "no"; // Is the coin mined? Answer "yes" or "no". If you answer "yes" a tag will indicate that this coin is mined.

// COIN 2
$coin2id = "investfeed";
$coin2qua = 1000;
$coin2inv = 75;
$coin2mined = "no";

// COIN 3
$coin3id = "tenx";
$coin3qua = 70;
$coin3inv = 146;
$coin3mined = "no";

// COIN 4
$coin4id = "verge";
$coin4qua = 10000;
$coin4inv = 43;
$coin4mined = "no";

// COIN 5
$coin5id = "basic-attention-token";
$coin5qua = 250;
$coin5inv = 22;
$coin5mined = "no";

// COIN 6
$coin6id = "bitquence"; 
$coin6qua = 150; 
$coin6inv = 120; 
$coin6mined = "no";

// COIN 7 - MINED COIN
$coin7id = "ethereum";
$coin7qua = 0.447;
$coin7inv = 0;
$coin7mined = "yes";


///////////// WATCHLIST ////////////////////

$watchcoinnr = 10; // The NUMBER of the different kinds of cryptocoins you own, e.g. if you own Bitcoin, Ethereum, and Ripple this NUMBER will be 3.
$watchcurrency = "USD"; // the CURRENCY of your choice. Valid values are: "USD", "CAD", "CNY", "EUR", "GBP", and "BTC". Remember to register your expenses/investments on the same currency.

$watchcoin1id = "bitcoin"; //the ID of the coin.

$watchcoin2id = "ethereum";

$watchcoin3id = "eos";

$watchcoin4id = "stratis";

$watchcoin5id = "litecoin";

$watchcoin6id = "tenx";
$watchcoin6paper = "https://www.tenx.tech/whitepaper/tenx_whitepaper_final.pdf";

$watchcoin7id = "basic-attention-token";

$watchcoin8id = "civic";
$watchcoin8web = "https://www.civic.com/";
$watchcoin8paper = "https://tokensale.civic.com/CivicTokenSaleWhitePaper.pdf";

$watchcoin9id = "monetha";

$watchcoin10id = "investfeed";
$watchcoin10web = "https://www.investfeed.com/";
$watchcoin10paper = "https://www.investfeed.com/upload/investFeedInc.TokenSale.pdf";


///////////// NEWS ////////////////////

$newslink = "http://rssmix.com/u/8252235/rss.xml"; // the RSS feed link for news. RSSMIX.com is a nice service for mixing several RSS feeds.
$newsnumber = "40"; // The NUMBER of NEWS stories you want to get.

///////////// COMMUNITY POSTS ////////////////////

$communitypostslink = "http://rssmix.com/u/8252418/rss.xml"; // the RSS feed link for community posts. RSSMIX.com is a nice service for mixing several RSS feeds.
$communitypostsnumber = "40"; // The NUMBER of COMMUNITY POSTS you want to get.

?>