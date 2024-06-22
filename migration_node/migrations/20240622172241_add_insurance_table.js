exports.up = async function (knex) {
  await knex.schema.dropTableIfExists("ms_insurance_policy");
  await knex.schema.createTable("ms_insurance_policy", (table) => {
    table.increments("insurance_id").primary();
    table.date("rid");
    table.integer("ct_id");
    table.integer("cust_id");
    table.string("reg_name");
    table.text("policy_no");
    table.integer("bd_id");
    table.integer("agent_id");
    table.string("agent_no");
    table.date("policy_date");
    table.integer("fuel_id");
    table.integer("code_id");
    table.decimal("premium", 20, 3);
    table.decimal("gst", 20, 3);
    table.decimal("net_premium", 20, 3);
    table.decimal("idv", 20, 3);
    table.integer("pm_id");
    table.integer("vehicle_id");
    table.integer("fp_id");
    table.integer("it_id");
    table.enu("i_is_active", ["Y", "N"]).defaultTo("Y");
    table.integer("created_by").defaultTo();
    table.datetime("created_at").defaultTo();
    table.integer("updated_by").defaultTo();
    table.datetime("updated_at").defaultTo();
    table.index("insurance_id");
    table.index("ct_id");
    table.index("cust_id");
    table.index("bd_id");
    table.index("agent_id");
    table.index("fuel_id");
    table.index("code_id");
    table.index("pm_id");
    table.index("vehicle_id");
    table.index("fp_id");
    table.index("it_id");
  });
};

exports.down = async function (knex) {
  await knex.schema.dropTableIfExists("ms_insurance_policy");
};
