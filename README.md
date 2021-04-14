# wp-mintfit

wp-mintfit is a WordPress Plugin. It provides a local REST-API for MINTFIT user data.
The data is periodically updated using `wp-cron`. Some more features will be added soon.

> This plugin is currently in beta. Try at your own risk.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Support](#support)
- [Contributing](#contributing)

## Installation

To build `wp-mintfit` you need have `npm` installed. 
Additionally you may need some tools, which are available as `coreutils` on many Linux distributions and Mac.
Depending on your system the package may be written a little bit differently.
Building on Windows is currently not supported. But if you can are able to read `build.sh`, you should be able to build it anyway. 

Clone this repository and execute `build.sh` to build an installable zip-file.

```sh
git clone git@github.com:jdillenberger/wp-mintfit.git
cd ./wp-mintfit
bash ./build.sh
```

You can now upload the installable zip-archive in WordPress admin to install it and then activate it. [More Information ](https://wordpress.org/support/article/managing-plugins/#manual-upload-via-wordpress-admin)

## Usage

### Configuration

After wp-mintfit is installed and activated in WordPress the admin menu contains a `Mintfit` section
which includes the following subsections: 

- Options
- Results

To get the plugin to work - you first need to go to the `Options` page. To add your `client-id` and `client-secret`.
Without those two keys the plugin won't work.

### API Usage

The Plugin extends the WordPress REST-API. Use the following REST GET endpoint to access a users data.

```index.php/wp_json/mintfit/v1/test/{test_id}```

> To use the rest-api you need a `wp-rest` WordPress nonce. [More Information](https://codex.wordpress.org/WordPress_Nonces)

Just replace `{test_id}` by `all` or by a valid MINTFIT `test_id` such as `math1` or `physics`. 

Users that have the `mintfit_view_results` capability can use the endpoint as follows to access the results for all synchronized users. 
This capability is by default only granted to administators.

```index.php/wp_json/mintfit/v1/test/{test_id}?all_users=true```

## Support

Please [open an issue](https://github.com/jdillenberger/wp-mintfit/issues/new) for support.

## Contributing

Please contribute using [Github Flow](https://guides.github.com/introduction/flow/). Create a branch, add commits, and [open a pull request](https://github.com/jdillenberger/wp-mintfit/compare).
