Storage Concepts:

- `Repositories` (Maps a storage engine; elasticsearch, MySQL, Api; to an unified interface)
- `Hydrators` (Hydrates results into specific formats e.g. Eloquent models, Objects, Arrays etc...)
- `Criteria` (Specific domain based queries e.g. `Approved` `Draft`)
- `ParameterQueries` (maps url params to repository queries)