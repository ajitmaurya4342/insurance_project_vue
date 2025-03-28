
exports.up = async function (knex) {
    await knex.schema.alterTable("add_credit_note_company", (table) => {
        table.integer("parent_c_ref_id").after("c_ref_id").defaultTo(0);
    });
};

exports.down = async function (knex) {
    await knex.schema.alterTable("add_credit_note_company", (table) => {
        table.dropColumn("parent_c_ref_id");
    });
};
