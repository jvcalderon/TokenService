Token service
==============

A dockerized microservice who provides a REST interface with token's common functionality.

## Installation

You need Composer to install dependencies:

<pre><code>$ composer install #use --no-dev option in a production environment</code></pre>

Now you must up Docker containers by docker-compose. This command will build a PHP container with XDEBUG configuration
(recommended for develop purposes):

<pre><code>$ export ENV=dev; docker-compose -f docker-compose.yml -f ./config/docker/${ENV}/docker-compose.yml up --build -d</code></pre>

In a production environment is recommended the following command without XDEBUG config:

<pre><code>$ export ENV=prod; docker-compose up --build -d</code></pre>

### Create database schema

Use doctrine binary to create DB schema:

<pre><code>$ php bin/doctrine orm:schema-tool:create</code></pre>

## Debugging with XDEBUG:

You must to keep in mind that the Xdebug's default port (9000) has been replaced by 9089 to avoid collision with PHP CGI.
Remote host IP is 10.254.254.254 (de facto standard host address alias) so you need to create the alias:

<pre><code>$ ifconfig lo0 alias 10.254.254.254</code></pre>

If you are using MacOS I recommend to read: [Docker (Mac) De-facto Standard Host Address Alias](https://gist.github.com/ralphschindler/535dc5916ccbd06f53c1b0ee5a868c93)

## Basic use

Now you can use the REST API to consume the service:

<table>
	<thead>
		<tr>
			<td><strong>Route</strong></td>
			<td><strong>Method</strong></td>
			<td><strong>Params</strong></td>
			<td><strong>Description</strong></td>
		</tr>
	</thead>
	<tbody>
        <tr>
            <td><strong>/</strong></td>
            <td><strong>POST</strong></td>
            <td><strong>-</strong></td>
            <td><strong>Create a new token. you can get it by 'Location' response header. This token expires in 14 days of inactivity.</strong></td>
        </tr>
        <tr>
            <td><strong>/{tokenId}</strong></td>
            <td><strong>GET</strong></td>
            <td><strong>-</strong></td>
            <td><strong>Retrieve the token data in hal+json format and update expiration datetime.</strong></td>
        </tr>
        <tr>
            <td><strong>/{tokenId}</strong></td>
            <td><strong>DELETE</strong></td>
            <td><strong>-</strong></td>
            <td><strong>Expires the token.</strong></td>
        </tr>
	</tbody>
</table>