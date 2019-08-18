## Goal:

- Set up Drupal 8 to be a consumer of the [Open Brewery DB API](https://www.openbrewerydb.org/#documentation)
- Create a Batch process to grab data
  - Continue to run batch process until either:
    1. Response is empty OR
    2. Response size is less than the request per_page value
- Create a Cron Job to run this batch process every so often
- Display the Brewery data as a View page

## Resources

- https://www.metaltoad.com/blog/drupal-8-consumption-third-party-api
