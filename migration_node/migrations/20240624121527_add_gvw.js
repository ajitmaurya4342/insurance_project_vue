exports.up = async function (knex) {
  await knex.schema.alterTable("ms_insurance_policy", (table) => {
    table.string("gvw").after("idv");
  });
};

exports.down = async function (knex) {
  await knex.schema.alterTable("ms_insurance_policy", (table) => {
    table.dropColumn("gvw");
  });
};
