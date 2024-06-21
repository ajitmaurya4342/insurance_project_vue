exports.up = async function (knex) {
  await knex.schema.dropTableIfExists("ms_fuel_type");
  await knex.schema.dropTableIfExists("ms_bank_department");
  await knex.schema.createTable("ms_fuel_type", (table) => {
    table.increments("fuel_id").primary();
    table.string("fuel_type_name");
    table.integer("created_by").defaultTo();
    table.datetime("created_at").defaultTo();
    table.integer("updated_by").defaultTo();
    table.datetime("updated_at").defaultTo();
    table.index("fuel_id");
  });

  await knex.schema.createTable("ms_bank_department", (table) => {
    table.increments("bd_id").primary();
    table.string("bank_dept_name");
    table.integer("created_by").defaultTo();
    table.datetime("created_at").defaultTo();
    table.integer("updated_by").defaultTo();
    table.datetime("updated_at").defaultTo();
    table.index("bd_id");
  });

  await knex.schema.alterTable("ms_company_type", (table) => {
    table.string("seller_type").after("company_type_name");
    table.string("company_phone").after("company_type_name");
    table.string("company_address").after("company_type_name");
  });

  await knex.schema.createTable("ms_customer", (table) => {
    table.increments("cust_id").primary();
    table.string("vehicle_no");
    table.string("cust_name");
    table.string("cust_phone");
    table.string("cust_address");
    table.integer("created_by").defaultTo();
    table.datetime("created_at").defaultTo();
    table.integer("updated_by").defaultTo();
    table.datetime("updated_at").defaultTo();
    table.index("cust_id");
  });
};

exports.down = async function (knex) {
  await knex.schema.dropTableIfExists("ms_customer");
  await knex.schema.dropTableIfExists("ms_fuel_type");
  await knex.schema.dropTableIfExists("ms_bank_department");
  await knex.schema.alterTable("ms_company_type", (table) => {
    table.dropColumn("seller_type");
    table.dropColumn("company_phone");
    table.dropColumn("company_address");
  });
};
