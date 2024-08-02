# Wordpress Alias URL Stream Plugin

**Version:** 1.0.1<br>
**Author:** NuoBiT Solutions, S.L.<br>
**License:** AGPLv3

## Description:

Enables server-side mapping of a single file to multiple virtual names without duplicating or renaming the file on the server. Using a custom path '/alias/' to differentiate between the real and virtual parts of a URL, this plugin enhances the flexibility of file URL naming, allowing users to access and download files with any custom name while serving from the original source.

## Core Functionality:

- **Single Source, Multiple Names**: Host a file once on your server, irrespective of its name – whether it's user-friendly or a unique identifier like `dd0588c172986c32636ffdd8cc690de7b41bf253.pdf`. This plugin allows users to virtually access and download that file with any custom name they prefer.

- **Dynamic Virtual Naming**: By using a specified keyword (e.g., "alias"), users can create virtual paths to the original file. For instance, accessing the URL `https://yourwebsite.com/reports/2023/10/dd0588c172986c32636ffdd8cc690de7b41bf253.pdf/alias/test.pdf` will serve the contents of the original `https://yourwebsite.com/reports/2023/10/dd0588c172986c32636ffdd8cc690de7b41bf253.pdf` file but under the new virtual name `test.pdf`.

- **Efficient File Delivery**: There are no redirections or complex server rerouting involved. The plugin efficiently maps the virtual name to the original file, ensuring seamless file delivery.

## Use Cases:

- **Custom File Naming for Different Audiences**: Share the same file with different groups under different names without having to duplicate the file on the server.

- **SEO and Marketing Considerations**: Serve the file under different virtual names for SEO or marketing campaigns while maintaining a single source of truth on the server.

- **Temporary Naming**: For temporary events or promotions, give a file a custom virtual name without altering its original path or name.

## GitHub Repository:

[NuoBiT's Github Repository](https://github.com/nuobit/wp-alias-url-stream)

