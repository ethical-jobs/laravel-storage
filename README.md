
## Compatibility

 - `v2.*` - Laravel 8 or higher
 - `v1.*` - Laravel 5.6 to 5.9. Laravel 7 support unknown

## Storage Concepts:

- `Repositories` (Maps a storage engine; elasticsearch, MySQL, Api; to an unified interface)
- `Hydrators` (Hydrates results into specific formats e.g. Eloquent models, Objects, Arrays etc...)
- `Criteria` (Specific domain based queries e.g. `Approved` `Draft`)
- `ParameterQueries` (maps url params to repository queries)

## Deprecation warning

All current EJ packages will be taken offline by mid-2021 in order to re-released under a single package.
