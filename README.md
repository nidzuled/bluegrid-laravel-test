## Bluegrid task

Create an application using the Laravel framework that contains a feature to fetch data from the https://rest-test-eight.vercel.app/api/test endpoint, transform the result to meet a specific data structure, and store the data into the database. The application should also have three exposed endpoints:

/api/files-and-directories - Parses data from the external API endpoint and returns a new data structure with all directories and files.
/api/directories - Lists only directories.
/api/files - Lists only files.
Besides the endpoints, the application needs to log a timestamp for the specific event:

When the new data is fetched from the external API.
The /api/directories-and-files endpoint should return data in the following form:
```
{
  "<IP adress>": [
    {
      "<directory name>": [
        {
          "<sub-directory name>": [
            "<file name>",
            "<file name>",
            "<file name>"
          ]
        },
        {
          "<sub-directory name>": [
            "<file name>",
            "<file name>",
            "<file name>"
          ]
        },
        "<file name>",
        "<file name>",
        "<file name>"
      ]
    },
    {
      "<directory name>": [
        "<file name>",
        "<file name>",
        "<file name>"
      ]
    }
  ]
}
```
The /api/directories endpoint should return a paginated list of directories in an array, with a limit of 100 records per page. The /api/files endpoint should return a paginated list of files in an array, with a limit of 100 records per page.

An important note is that the external endpoint returns a large dataset and has a delay of about ten seconds. In addition to data transformation, the application should save directories into the directories table and files into the files table. The end user should receive a response as quickly as possible for all three endpoints. This means it is necessary to create a mechanism that ensures the endpoints don’t have a significant delay in response time.

The code needs to be uploaded to a GitHub repository for review. Additionally, the application needs to function in a local environment for easier testing.

## About project and structure

For this project Laravel 11 was used with `sail` for local development.

### Requirements:

- Installed [Docker Compose](https://docs.docker.com/compose/install/) or [Docker Desktop](https://www.docker.com/products/docker-desktop/)

### Starting project
- Run command `./vendor/bin/sail up`
- Run migration `./vendor/bin/sail artisan migrate`

### Project structure

The default Laravel application structure is used. With adding extra namespace `App\Services\Vercel` for better organisation.
All logic related to transforming request and storing directories and files is there.

### Running tests

```bash
./vendor/bin/sail artisan test
```
### Running php linter

```bash
./vendor/bin/duster lint --dirty
```
