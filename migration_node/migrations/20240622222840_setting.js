exports.up = async function (knex) {
  await knex.schema.createTable("setting", (table) => {
    table.increments("setting_id").primary();
    table.string("gst");
  });

  await knex("setting").insert([
    {
      gst: "1.18",
    },
  ]);
};

exports.down = async function (knex) {
  await knex.schema.dropTableIfExists("setting");
};
