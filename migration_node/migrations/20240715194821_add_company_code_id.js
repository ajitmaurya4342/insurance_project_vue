
exports.up =async function(knex) {

  await knex.schema.alterTable("ms_insurance_policy", (table) => {
        table.text("remarks");
        table.text("hp_name");
   });
};

exports.down =async function(knex) {
    await knex.schema.alterTable("ms_insurance_policy", (table) => {
        table.dropColumn("remarks");
        table.dropColumn("hp_name");
    });
};
