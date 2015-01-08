-- ----------------------------
-- Vector cr_grid1 
-- ----------------------------
-- SELECT id, descripcion FROM zend_php_demo.n7_vistas_legajos;

-- SELECT 
--     p.id,
--     p.descripcion,
--     SPACE(120) AS contenido,
--     SPACE(120) AS contant,
--     000000000.00 AS pp_id,
--     vp.solo_lectura,
--     p.tipo_de_campo
-- FROM
--     zend_php_demo.n7_propiedades_l p,
--     zend_php_demo.n7_vistas_propiedades_l vp,
--     zend_php_demo.n7_vistas_legajos v
-- WHERE
--     p.id = vp.propiedad_id
--         AND vp.formulario_id = v.id
-- 		AND v.descripcion = "Alta de Legajo"
-- ORDER BY vp.orden

SELECT 
    p.id,
    p.descripcion,
    SPACE(120) AS contenido,
    SPACE(120) AS contant,
    000000000.00 AS pp_id,
    vp.solo_lectura,
    p.tipo_de_campo
FROM
    zend_php_demo.n7_vistas_propiedades_l vp
    -- zend_php_demo.n7_vistas_propiedades_l vp,
    -- zend_php_demo.n7_vistas_legajos v
    INNER JOIN
    zend_php_demo.n7_propiedades_l p ON p.id = vp.propiedad_id
    INNER JOIN
    zend_php_demo.n7_vistas_legajos v ON v.id = vp.formulario_id
WHERE
	v.descripcion = "Alta de Legajo"
    -- p.id = vp.propiedad_id
        -- AND vp.formulario_id = v.id
		-- AND v.descripcion = "Alta de Legajo"
ORDER BY vp.orden
