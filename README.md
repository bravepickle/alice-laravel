# alice-laravel
Alice's fixtures generator integration to Laravel Framework

## Features
1. Implemented ModelLoader class for loading data from Alice configs to Eloquent models
2. Added GenericModel abstraction for supporting tables that have no Laravel models present. Useful when databases 
are shared, have temporary tables or some tables should be accessed indirectly

## TODO
- [ ] write unit tests
- [ ] multiple database support
- [ ] common variables support
- [ ] extra settings for ModelLoader such as locale, extra helper functions and other
- [ ] context options that define if ModelLoader should just create models or additionally use factory methods or create and save to DB
- [ ] relations update and save using Eloquent models
- [ ] saving to database resulting sets in transactions and with disabled foreign key checks 
