// Update with your config settings.

module.exports = {
  development: {
    client: "mysql2",
    connection: {
      host: "localhost",
      database: "insurance_db",
      password: "",
      user: "root",
    },
    migrations: {
      tableName: "knex_migrations",
    },
  },
};
