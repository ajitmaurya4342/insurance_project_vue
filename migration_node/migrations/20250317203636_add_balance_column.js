
exports.up = async function (knex) {

    await knex.schema.alterTable("ms_payment_mode", (table) => {
        table.decimal("balance", 20, 4).defaultTo(0);
    });
};

exports.down = async function (knex) {
    await knex.schema.alterTable("ms_payment_mode", (table) => {
        table.dropColumn("balance");
    });
};
