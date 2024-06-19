exports.up = async function (knex) {
  await knex.schema.createTable("users", (table) => {
    table.increments("user_id").primary();
    table.string("name");
    table.string("mobile_number");
    table.string("username");
    table.string("password");
    table.enu("user_type", ["admin", "user"]);
    table.integer("created_by").defaultTo();
    table.datetime("created_at").defaultTo();
    table.integer("updated_by").defaultTo();
    table.datetime("updated_at").defaultTo();
  });

  await knex("users").insert([
    {
      name: "admin",
      username: "admin",
      password: "admin@123",
      user_type: "admin",
    },
    {
      name: "Deepak Gupta",
      username: "deepak",
      password: "deepak@123",
      user_type: "user",
    },
  ]);
};

exports.down = async function (knex) {
  await knex.schema.dropTableIfExists("users");
};
