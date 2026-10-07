<?php
if (!defined('ABSPATH')) { exit; }
?>

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>WhatsApp Alert Builder</title>
<style>
  body { font-family: system-ui, sans-serif; background: #f3f4f6; display: flex; justify-content: center; padding: 32px 16px; }
  .alert-card { background: #fff; border-radius: 16px; box-shadow: 0 4px 16px rgba(0,0,0,.1); max-width: 460px; width: 100%; padding: 24px; }
  .alert-card h3 { margin: 0 0 16px; }
  .alert-card label { display: block; font-size: .85rem; color: #555; margin: 12px 0 4px; }
  .alert-card input, .alert-card select, .alert-card textarea { width: 100%; box-sizing: border-box; padding: 9px 10px; border: 1px solid #d1d5db; border-radius: 8px; font: inherit; }
  .row { display: flex; gap: 10px; } .row > div { flex: 1; }
  .preview { background: #dcf8c6; border-radius: 10px; padding: 12px; margin-top: 18px; white-space: pre-wrap; font-size: .95rem; min-height: 60px; }
  .count { text-align: right; font-size: .75rem; color: #777; margin-top: 4px; }
  .btn { display: block; width: 100%; box-sizing: border-box; padding: 12px; margin-top: 8px; border: 0; border-radius: 10px; font-size: 1rem; cursor: pointer; text-align: center; text-decoration: none; }
  .btn-primary { background: #25D366; color: #fff; font-weight: 600; }
  .btn-primary:hover { background: #1ebe5b; }
  .btn-secondary { background: #f3f4f6; color: #111; }
  .btn-secondary:hover { background: #e5e7eb; }
</style>
</head>
<body>

<!-- ===== CARD MARKUP (copy into your admin view) ===== -->
<div class="alert-card" id="alertCard">
  <h3>Create WhatsApp alert</h3>

  <label for="aType">Alert type</label>
  <select id="aType">
    <option value="new">🥾 New walk offer</option>
    <option value="reminder">⏰ Walk reminder</option>
    <option value="cancel">❌ Walk cancelled</option>
    <option value="change">⚠️ Walk update / change</option>
    <option value="general">📢 General notice</option>
  </select>

  <label for="aName">Name of walk / headline</label>
  <input id="aName" type="text" placeholder="e.g. Coastal path to Cap de la Nao">

  <div class="row">
    <div><label for="aDate">Date</label><input id="aDate" type="date"></div>
    <div><label for="aTime">Time</label><input id="aTime" type="time"></div>
  </div>

  <label for="aPlace">Meeting point</label>
  <input id="aPlace" type="text" placeholder="e.g. Car park by the lighthouse">

  <label for="aLeader">Leader</label>
  <input id="aLeader" type="text" placeholder="Optional">

  <label for="aLink">Link</label>
  <input id="aLink" type="url" placeholder="Optional, e.g. booking page">

  <label for="aNotes">Notes</label>
  <textarea id="aNotes" rows="3" placeholder="Optional"></textarea>

  <div class="preview" id="aPreview"></div>
  <div class="count" id="aCount"></div>

  <button class="btn btn-primary" id="aCopy" type="button">Copy alert</button>
  <a class="btn btn-secondary" href="https://web.whatsapp.com" target="_blank" rel="noopener noreferrer">Open WhatsApp Web</a>
  <button class="btn btn-secondary" id="aClear" type="button">Clear form</button>
</div>

<script>
(function () {
  const $ = id => document.getElementById(id);
  const fields = ["aType", "aName", "aDate", "aTime", "aPlace", "aLeader", "aLink", "aNotes"];

  const HEADERS = {
    new:     "🥾 *NEW WALK OFFER*",
    reminder:"⏰ *WALK REMINDER*",
    cancel:  "❌ *WALK CANCELLED*",
    change:  "⚠️ *WALK UPDATE*",
    general: "📢 *NOTICE*"
  };

  function fmtDate(v) {
    if (!v) return "";
    const d = new Date(v + "T00:00:00");
    return d.toLocaleDateString("en-GB", { weekday: "long", day: "numeric", month: "long", year: "numeric" });
  }

  // WhatsApp formatting: *bold*  _italic_  ~strike~
  function buildMessage() {
    const lines = [HEADERS[$("aType").value]];
    const name = $("aName").value.trim();
    if (name) lines.push("", "*" + name + "*");

    const details = [];
    if ($("aDate").value)  details.push("📅 " + fmtDate($("aDate").value));
    if ($("aTime").value)  details.push("🕘 " + $("aTime").value);
    if ($("aPlace").value.trim())  details.push("📍 " + $("aPlace").value.trim());
    if ($("aLeader").value.trim()) details.push("👤 Leader: " + $("aLeader").value.trim());
    if (details.length) lines.push("", ...details);

    if ($("aNotes").value.trim()) lines.push("", $("aNotes").value.trim());
    if ($("aLink").value.trim())  lines.push("", "🔗 " + $("aLink").value.trim());
    return lines.join("\n");
  }

  function refresh() {
    const msg = buildMessage();
    $("aPreview").textContent = msg;
    $("aCount").textContent = msg.length + " characters";
  }

  fields.forEach(id => {
    $(id).addEventListener("input", refresh);
    $(id).addEventListener("change", refresh);
  });

  $("aCopy").addEventListener("click", async () => {
    const msg = buildMessage();
    try {
      await navigator.clipboard.writeText(msg);
    } catch (e) {
      const t = document.createElement("textarea");
      t.value = msg;
      document.body.appendChild(t);
      t.select();
      document.execCommand("copy");
      t.remove();
    }
    $("aCopy").textContent = "Copied! Paste into your channel post";
    setTimeout(() => ($("aCopy").textContent = "Copy alert"), 2000);
  });

  $("aClear").addEventListener("click", () => {
    fields.forEach(id => { if (id !== "aType") $(id).value = ""; });
    refresh();
  });

  refresh();
})();
</script>
</body>

