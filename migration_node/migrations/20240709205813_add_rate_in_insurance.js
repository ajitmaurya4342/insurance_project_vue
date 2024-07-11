exports.up = async function (knex) {
   
    await knex.schema.alterTable("ms_insurance_policy", (table) => {
         table.enu("is_gst", ["Y", "N"]);
         table.decimal("purchase_rate", 20, 3);
         table.decimal("company_rate", 20, 3);
         table.decimal("agent_rate", 20, 3);
         table.decimal("code_rate", 20, 3);
         table.decimal("profit_rate", 20, 3);   
    });

    await knex("ms_payment_mode").insert([
        {
            "pm_id":"1",
            "pm_name":"By Agent"
        },
        {
            "pm_id":"2",
            "pm_name":"By Company"
        },
        {
            "pm_id":"3",
            "pm_name":"By Third Party Company"
        }
    ]);

    await knex.schema.createTable("add_credit_note_agent", (table) => {
        table.increments("a_ref_id").primary();
        table.integer("insurance_id");
        table.integer("agent_id");
        table.integer("pm_id");
        table.decimal("amount",11,4);
        table.text("description");
        table.datetime("payment_date").defaultTo();
        table.integer("created_by").defaultTo();
        table.datetime("created_at").defaultTo();
        table.index("insurance_id");
        table.index("agent_id");
        table.index("pm_id");
     });

     await knex.schema.createTable("add_credit_note_company", (table) => {
        table.increments("c_ref_id").primary();
        table.integer("insurance_id");
        table.integer("pm_id");
        table.integer("company_id");
        table.decimal("amount",11,4);
        table.text("description");
        table.datetime("payment_date").defaultTo();
        table.integer("created_by").defaultTo();
        table.datetime("created_at").defaultTo();
        table.index("insurance_id");
        table.index("company_id");
        table.index("pm_id");
     });


    
  };
  
  exports.down = async function (knex) {
    await knex.schema.alterTable("ms_insurance_policy", (table) => {
        table.dropColumn("is_gst");
        table.dropColumn("purchase_rate");
        table.dropColumn("company_rate");
        table.dropColumn("agent_rate");
        table.dropColumn("code_rate");
        table.dropColumn("profit_rate");
      });
    await knex.schema.dropTableIfExists("add_credit_note_agent");
    await knex.schema.dropTableIfExists("add_credit_note_company");
    await knex("ms_payment_mode").whereIn("pm_id",[1,2,3]).del()
  };
  