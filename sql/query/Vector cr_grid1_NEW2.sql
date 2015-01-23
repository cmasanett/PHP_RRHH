SELECT 
    p.id,
    p.descripcion,
    (SELECT 
            pp.valor
        FROM
            zend_php_demo.n7_ppd_l pp
        WHERE
            pp.propiedad_id = p.id
                AND pp.objeto_id = 3) AS contenido,
    -- (SELECT 
--             pp.valor
--         FROM
--             zend_php_demo.n7_ppd_l pp
--         WHERE
--             pp.propiedad_id = vp.propiedad_id
--                 AND pp.objeto_id = 3) AS contant,
--     (SELECT 
--             pp.id
--         FROM
--             zend_php_demo.n7_ppd_l pp
--         WHERE
--             pp.propiedad_id = vp.propiedad_id
--                 AND pp.objeto_id = 3) AS pp_id,
    vp.solo_lectura,
    p.tipo_de_campo
FROM
    zend_php_demo.n7_vistas_propiedades_l vp
        LEFT JOIN
    zend_php_demo.n7_propiedades_l p ON p.id = vp.propiedad_id
        LEFT JOIN
    zend_php_demo.n7_vistas_legajos v ON v.id = vp.formulario_id
WHERE
    v.descripcion = 'Alta de Legajo'
ORDER BY vp.orden;
