# wp-mintfit

wp-mintfit is a WordPress Plugin for Websites that have an `OAuth` integration with MINTFIT.
The Plugin periodically requests the MINTFIT API and stores the gathered data in the local database.
Furthermore it exposes its own REST-API, to query that data.

This way you don't have to expose your clientId/clientSecret in your JavaScript frontend, nor do you have to synchronously query the MINTFIT API on the server side for every request, which would be very slow.

> This plugin is currently in beta. Try at your own risk.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Support](#support)
- [Contributing](#contributing)

## Installation

To build `wp-mintfit` you need have `npm` installed.
Additionally you need the tools, which are available via a `coreutils` package on most Unix-like systems (Linux, Mac).
You'll have to figure out how to build it on Windows yourself, but that shouldn't be too hard. Just read the `build.sh`.

Clone this repository and execute `build.sh` to build an installable zip-file.

```sh
git clone git@github.com:jdillenberger/wp-mintfit.git
cd ./wp-mintfit
bash ./build.sh
```

You can now upload the installable zip-archive in WordPress admin to install it and then activate it. [More Information ](https://wordpress.org/support/article/managing-plugins/#manual-upload-via-wordpress-admin)

## Usage

### Admin Sections

After wp-mintfit is installed and activated in WordPress the admin menu contains a `Mintfit` section
which includes the following subsections: 

- Options
- Results

To get the plugin to work - you first need to go to the `Options` page. To add your `client-id` and `client-secret`.
Without those two keys the plugin won't work. 
In this section you can also select the tests from which data is to be synchronized.

Additionally you can use the results-page to view and delete data from your local database. 

### API Usage

The Plugin extends the WordPress REST-API. Use the following REST GET endpoint to access a users data.

```index.php/wp_json/mintfit/v1/test/{test_id}```

> To use the rest-api you need a `wp-rest` WordPress nonce. [More Information](https://codex.wordpress.org/WordPress_Nonces)

Just replace `{test_id}` by `all` or by a valid MINTFIT `test_id` such as `math1` or `physics`. 

Users that have the `mintfit_view_results` capability can use the endpoint as follows to access the results for all synchronized users. 
This capability is by default only granted to administators.

```index.php/wp_json/mintfit/v1/test/{test_id}?all_users=true```

### Post/Page Usage

In order to use wp-mintfit on your posts/pages, you need a solution that on the one hand allows you to make REST requests and on the other hand provides a way to use this data in your pages. 

I will present a solution for this soon here.

## Support

Please [open an issue](https://github.com/jdillenberger/wp-mintfit/issues/new) for support.

## Contributing

Please contribute using [Github Flow](https://guides.github.com/introduction/flow/). Create a branch, add commits, and [open a pull request](https://github.com/jdillenberger/wp-mintfit/compare).
