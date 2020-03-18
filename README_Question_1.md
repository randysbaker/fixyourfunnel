QUESTION:
---------
A SQL database table has grown very large. It has over 100,000,000 entries. The table is written to and read
from with some frequency. The table may need to be “sharded” without impacting the use of the software. How
would you solve this problem? If there is a better solution, what would that be?

ANSWER:
-------
The first thing I would optimize would be the indexes. You don't want to "over-index" a dataset, but at a minimal you 
should index important columns based on the way the data is being retreived. For example, a billing system may rountinely
lookup customer billing zipcode, last name, account number, etc. I would only index those specific columns. Another thing 
would be to ensure that the database tables are properly normalized. For example, seperate the billing information from the
services that the customer is subscribed to. I would also suggest creating a few custom MySQL 'views' so that individual 
tables are not queried multiple times for the relevant information each time a query is run. As a last case resort, I would
recommend creating horizontal shards in order to break up the larger tables. For instance, a customer table could be horizontally
sharded at each group of customers based on their last name. Example: A-F, G-K, etc.