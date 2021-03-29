Storage Concepts:

- `Repositories` (Maps a storage engine; elasticsearch, MySQL, Api; to an unified interface)
- `Hydrators` (Hydrates results into specific formats e.g. Eloquent models, Objects, Arrays etc...)
- `Criteria` (Specific domain based queries e.g. `Approved` `Draft`)
- `ParameterQueries` (maps url params to repository queries)

Requirements:
v2.0.0 - Laravel 8+
v1.* - Laravel 5.6, 5.7, 5.8, 5.9
