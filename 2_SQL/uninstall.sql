#Zen Cart v1.5.0+ only Below! Skip if using an older version!
DELETE FROM admin_pages WHERE page_key = 'configTPP' LIMIT 1;

SELECT @gid:=configuration_group_id
FROM configuration_group
WHERE configuration_group_title = 'Tabbed Products Pro - Configuration' LIMIT 1;
DELETE FROM configuration WHERE configuration_group_id = @gid;
DELETE FROM configuration_group WHERE configuration_group_id = @gid;
DELETE FROM configuration_group WHERE configuration_group_title = 'Tabbed Products Pro - Configuration';