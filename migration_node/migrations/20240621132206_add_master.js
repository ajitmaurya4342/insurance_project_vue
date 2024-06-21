exports.up = async function (knex) {
  await knex.schema.createTable("ms_agent", (table) => {
    table.increments("agent_id").primary();
    table.string("agent_name");
    table.string("agent_mobile_number");
    table.string("agent_address");
    table.integer("created_by").defaultTo();
    table.datetime("created_at").defaultTo();
    table.integer("updated_by").defaultTo();
    table.datetime("updated_at").defaultTo();
    table.index("agent_id");
  });

  await knex.schema.createTable("ms_vehicle", (table) => {
    table.increments("vehicle_id").primary();
    table.string("vehicle_type");
    table.integer("created_by").defaultTo();
    table.datetime("created_at").defaultTo();
    table.integer("updated_by").defaultTo();
    table.datetime("updated_at").defaultTo();
    table.index("vehicle_id");
  });

  await knex.schema.createTable("ms_payment_mode", (table) => {
    table.increments("pm_id").primary();
    table.string("pm_name");
    table.integer("created_by").defaultTo();
    table.datetime("created_at").defaultTo();
    table.integer("updated_by").defaultTo();
    table.datetime("updated_at").defaultTo();
    table.index("pm_id");
  });

  await knex.schema.createTable("ms_fp_tp_type", (table) => {
    table.increments("fp_id").primary();
    table.string("fp_type");
    table.integer("created_by").defaultTo();
    table.datetime("created_at").defaultTo();
    table.integer("updated_by").defaultTo();
    table.datetime("updated_at").defaultTo();
    table.index("fp_id");
  });

  await knex.schema.createTable("ms_insurance_type", (table) => {
    table.increments("it_id").primary();
    table.string("insurance_type_name");
    table.integer("created_by").defaultTo();
    table.datetime("created_at").defaultTo();
    table.integer("updated_by").defaultTo();
    table.datetime("updated_at").defaultTo();
    table.index("it_id");
  });

  await knex.schema.createTable("ms_company_type", (table) => {
    table.increments("ct_id").primary();
    table.string("company_type_name");
    table.integer("created_by").defaultTo();
    table.datetime("created_at").defaultTo();
    table.integer("updated_by").defaultTo();
    table.datetime("updated_at").defaultTo();
    table.index("ct_id");
  });

  await knex("ms_agent").insert([
    {
      agent_name: "Self",
    },
  ]);
};

exports.down = async function (knex) {
  await knex.schema.dropTableIfExists("ms_vehicle");
  await knex.schema.dropTableIfExists("ms_agent");
  await knex.schema.dropTableIfExists("ms_insurance_type");
  await knex.schema.dropTableIfExists("ms_fp_tp_type");
  await knex.schema.dropTableIfExists("ms_payment_mode");
  await knex.schema.dropTableIfExists("ms_company_type");
};
