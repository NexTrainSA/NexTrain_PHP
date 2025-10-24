let trajId = 0;

let orig, dst;
let trajectoryGroup, itineraryEl;

function updateOriginDest(itinerary) {
    // Return a Promise that resolves when both origin and destination are fetched
    return new Promise((resolve, reject) => {
        if (itinerary == null || itinerary === "") {
            orig = null;
            dst = null;
            resolve();
            return;
        }
        var req1 = $.get("php/get_orig_itinerario.php?id_itinerario=" + itinerary);
        var req2 = $.get("php/get_dest_itinerario.php?id_itinerario=" + itinerary);
        $.when(req1, req2).done(function(origData, dstData) {
            // jQuery returns arrays [data, statusText, jqXHR] when used with $.when
            orig = parseInt(origData[0], 10);
            dst = parseInt(dstData[0], 10);
            console.log("Origin: " + orig);
            console.log("Destination: " + dst);
            resolve();
        }).fail(function(err) {
            console.error("Failed to load origin/destination", err);
            reject(err);
        });
    });
}

function createTrajectorySelect(id) {
    if (orig == null) {
        const itineraryVal = itineraryEl ? itineraryEl.value : null;
        if (itineraryVal == null || itineraryVal === "") {
            // No itinerary selected yet; avoid infinite recursion
            return;
        }
        return updateOriginDest(itineraryVal).then(() => createTrajectorySelect(id)).catch(() => {});
    }

    const select = document.createElement("select");
    select.id = "trajectory" + id;
    select.name = "trajectory" + id;

    let lastNode;
    const prev = document.getElementById("trajectory" + (id - 1));
    if (prev == null) lastNode = orig;
    else lastNode = parseInt(prev.value, 10);

    if (lastNode == null || Number.isNaN(lastNode)) {
        console.warn("Cannot create trajectory select: lastNode is null");
        return;
    }

    trajectoryGroup.appendChild(select);

    $.get("php/listar_arestas_estacao.php?id_estacao=" + lastNode, function(data) {
        var json;
        try {
            json = typeof data === "string" ? $.parseJSON(data) : data;
        } catch (e) {
            console.error("Invalid JSON for edges", e);
            json = [];
        }
        console.log(json);
        if (!json || json.length === 0) return;
        json.forEach((el) => {
            let option = document.createElement("option");
            option.text = el.n2;
            option.value = el.id_estacao2;
            select.appendChild(option);
        });
    }).fail(function(err) {
        console.error("Failed to list edges for station", lastNode, err);
    });

    select.addEventListener("change", function() {
        const idx = parseInt(this.id.replace(/\D+/g, ""), 10);

        // Remove every select beneath the changed one
        for (let i = idx + 1; ; i++) {
            const next = document.getElementById("trajectory" + i);
            if (!next) break;
            trajectoryGroup.removeChild(next);
        }

        // Update the last index to the changed one
        trajId = idx;

        const val = parseInt(this.value, 10);
        if (!Number.isNaN(val) && dst != null && val === dst) {
            alert("Destino atingido!");
            return;
        }

        // Create the next select from this point
        trajId++;
        createTrajectorySelect(trajId);
    });
}

window.addEventListener("load", function() {
    trajectoryGroup = document.getElementById("trajectory-group");
    itineraryEl = document.getElementById("itinerary");

    if (itineraryEl) {
        itineraryEl.addEventListener("change", function() {
            // Clear previous trajectory selects and reset state
            if (trajectoryGroup) trajectoryGroup.innerHTML = "";
            trajId = 0;
            orig = null;
            dst = null;

            if (trajectoryGroup && itineraryEl.value) {
                createTrajectorySelect(trajId);
            }
        });
    }

    // Initialize
    if (trajectoryGroup) createTrajectorySelect(trajId);
});

document.getElementById("formOS").addEventListener("submit", function() {
    const trajectoryIds = [];
    for (let i = 0; ; i++) {
        const select = document.getElementById("trajectory" + i);
        if (select == null) break;
        trajectoryIds.push(select.value);
    }
    const hiddenInput = document.createElement("input");
    hiddenInput.type = "hidden";
    hiddenInput.name = "full_trajectory";
    hiddenInput.value = trajectoryIds.join(",");
    this.appendChild(hiddenInput);
});